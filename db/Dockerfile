FROM mysql:5.7.29

RUN mkdir -p /var/log/mysql
RUN touch /var/log/mysql/mysqld.log

RUN mkdir -p /etc/mysql/conf.d
ADD ./conf.d/my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod -R 644 /etc/mysql/conf.d
