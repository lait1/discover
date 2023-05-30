FROM node:16

RUN apt-get update && apt-get install -y iputils-ping

WORKDIR /symfony

COPY package.json package.json
COPY package-lock.json package-lock.json

RUN npm install

ENTRYPOINT ping 127.0.0.1 > /dev/null