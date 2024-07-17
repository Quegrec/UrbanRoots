# production/Dockerfile
FROM node:18-alpine

WORKDIR /app

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY ./frontend/package*.json ./

RUN npm install --production

# Copier le reste du code source
COPY ./frontend/ ./

RUN npm run build

EXPOSE 3000

CMD ["npm", "start"]
