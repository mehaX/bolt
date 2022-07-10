rm -rf dist
mkdir dist

docker build -t bolt:latest --platform amd64 .
docker save --output dist/bolt.tar bolt:latest
