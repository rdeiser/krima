docker build -t rdeiser/krima -f ./Dockerfile ../dist
docker build -t rdeiser/krima:php72 -f ./Dockerfile --build-arg phpImg=php:7.2 ../dist
docker build -t rdeiser/krima:php71 -f ./Dockerfile --build-arg phpImg=php:7.1 ../dist
docker build -t rdeiser/krima:php70 -f ./Dockerfile --build-arg phpImg=php:7.0 ../dist
