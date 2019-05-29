FROM php:7.2-cli

ARG tcp_ip

WORKDIR /app

COPY ./ ./

RUN export TCP_IP=${tcp_ip}
#RUN php -v
RUN echo $TCP_IP