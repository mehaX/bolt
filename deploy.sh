# scp dist/bolt.tar root@mehax.dev:/var/www/vhosts/mehax.dev/bolt.mehax.dev
ssh root@mehax.dev "docker stop bolt"
ssh root@mehax.dev "docker rm bolt"
ssh root@mehax.dev "docker rmi bolt:latest"
ssh root@mehax.dev "docker load --input /var/www/vhosts/mehax.dev/bolt.mehax.dev/bolt.tar"
ssh root@mehax.dev "docker run -d -p 6001:80 --name bolt bolt:latest"
