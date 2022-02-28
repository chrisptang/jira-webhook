<?php
// router.php
error_log("incoming request for:" . $_ENV["WEBHOOK_URL"]);
error_log("incoming request for:" . $_ENV["MESSAGE_TEMPLATE"]);

error_log($_SERVER['QUERY_STRING']);

// Takes raw data from the request
$json = file_get_contents('php://input');

error_log('json:' . $json);

// Converts it into a PHP object
$data = json_decode($json);

$url = $_ENV["WEBHOOK_URL"];

// Create a new cURL resource
$ch = curl_init($url);

$url = sprintf('https://jira.minisobos.com/browse/%s-%d', $_POST['project_key'], $_POST['issue_id']);
$user = $_POST['user_name'];
$content = str_replace("__content__", sprintf("%s 创建了一个新issue：%s", $user, $url), $_ENV["MESSAGE_TEMPLATE"]);


// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);

echo $result;

// ${board.id}${comment.id}${issue.id}${issue.key}${mergedVersion.id}${modifiedUser.key}
// ${modifiedUser.name}${project.id}${project.key}${sprint.id}${version.id}