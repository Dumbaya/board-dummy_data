FROM centos:8

RUN sed -i 's/mirrorlist/#mirrorlist/g' /etc/yum.repos.d/CentOS-*
RUN sed -i 's|#baseurl=http://mirror.centos.org|baseurl=http://vault.centos.org|g' /etc/yum.repos.d/CentOS-*

RUN yum -y update && \
    yum -y install httpd php php-cli php-mysqlnd php-pdo php-common php-xml php-mbstring php-json && \
    yum -y install mod_security && \
    yum clean all

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80

ENV TZ Asia/Seoul

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]