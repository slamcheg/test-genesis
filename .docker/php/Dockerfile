FROM ubuntu:16.04

RUN apt-get clean && apt-get -y update && apt-get install -y locales curl software-properties-common git \
  && locale-gen en_US.UTF-8
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php \
&& apt-get update \
&& apt-get install -y --force-yes \
php7.2-bcmath \
php7.2-bz2 \
php7.2-cli \
php7.2-common \
php7.2-curl \
php7.2-cgi \
php7.2-dev \
php7.2-fpm \
php7.2-gd \
php7.2-json \
php7.2-mbstring \
php7.1-mcrypt \
php7.2-mysql \
php7.2-xml \
php7.2-xmlrpc \
php7.2-xsl \
php7.2-zip  \
php7.2-xdebug  \
php7.2-gmp \
php-mongodb \
ant \
supervisor

RUN curl https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php
RUN composer global require "fxp/composer-asset-plugin:^1.3.1"

RUN sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www
ADD .docker/php/docker-endpoint.sh /docker-endpoint.sh
RUN chmod 755 /docker-endpoint.sh

RUN usermod -u 1000 www-data
ENV TERM xterm

#cli
EXPOSE 17786

EXPOSE 9000
ENTRYPOINT ["/docker-endpoint.sh"]
CMD supervisord -c /etc/supervisor/supervisord.conf