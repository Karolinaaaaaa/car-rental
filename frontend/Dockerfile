FROM node:18-alpine

WORKDIR /app

COPY package*.json ./
RUN npm install -g http-server && npm install

COPY . .

EXPOSE 4200
CMD ["http-server", ".", "-p", "4200"]
