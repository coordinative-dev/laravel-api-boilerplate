FROM nginx:1.10.3

ARG NGINX_ENV=local

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./web-${NGINX_ENV}.conf /etc/nginx/conf.d

EXPOSE 80
