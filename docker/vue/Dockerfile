FROM node:18.20.1-bullseye

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar el package.json y package-lock.json
COPY ./frontend/package*.json ./

# Instalar las dependencias
RUN npm install

# Copiar el resto del código de la aplicación
COPY ./frontend .

# Exponer el puerto en el que se ejecutará la aplicación
EXPOSE 5173
CMD ["npm", "run", "dev", "serve"]