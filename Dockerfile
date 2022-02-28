FROM  php:8-alpine3.14

ENV WEBHOOK_URL 'https://dingtalk-bot-url/?accessToken=foo'
ENV MESSAGE_TEMPLATE '{"msgtype":"text","text":{"content":"__content__"}}'
ENV SERVER_PORT 8086

RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
RUN echo 'Asia/Shanghai' >/etc/timezone

COPY ./jira_webhook.php /app/jira_webhook.php
WORKDIR /app
EXPOSE $SERVER_PORT
CMD php -S 0.0.0.0:$SERVER_PORT