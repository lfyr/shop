FROM kaoyaya-registry.cn-beijing.cr.aliyuncs.com/kaoyaya-micro/php7-nginx:latest

RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai  /etc/localtime

ENV WORKPATH /var/www/html

RUN mkdir -p $WORKPATH/shop

WORKDIR $WORKPATH/shop

COPY . $WORKPATH/shop

COPY deploy/default  /etc/nginx/conf.d/default.conf

RUN chmod -R 777 $WORKPATH/shop/Application/Runtime

EXPOSE 80

#启动示例
#docker build -t shop .
#docker run --name shop  -p 8082:80 -d shop
#docker exec -it shop /bin/bash