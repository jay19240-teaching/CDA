FROM node:lts-alpine as build-stage
ARG MODE

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
COPY .env.${MODE} .env
RUN npm run build

# production stage
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]