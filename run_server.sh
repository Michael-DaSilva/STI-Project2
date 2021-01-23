#!/bin/bash
docker stop sti_project
docker rm -f sti_project
docker run -ti -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018
docker cp site/. sti_project:/usr/share/nginx/
docker exec -u root sti_project bash -c 'chmod 777 -R /usr/share/nginx/databases/'
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start