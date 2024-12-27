FROM node:lts-alpine as build-stage
ARG MODE=test

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
COPY .env.${MODE} .env
RUN npm run build

# production stage
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
CMD ["nginx", "-g", "daemon off;"]