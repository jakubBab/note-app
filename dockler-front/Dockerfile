FROM node:15.12.0-alpine

# set working directory
WORKDIR /usr/src/app/my-app

COPY package*.json ./

# install and cache app dependencies
RUN npm install
RUN npm install -g @vue/cli

#RUN npm run build
# start app
CMD ["npm", "run", "serve"]