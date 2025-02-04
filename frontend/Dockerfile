# Use Node.js 20.12.2 image
FROM node:20.12.2

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json ./

# Install dependencies
RUN yarn install --frozen-lockfile

# Copy project files (but exclude node_modules)
COPY . .

# Build the project
RUN yarn build

# Expose port for development
EXPOSE 5173
CMD ["yarn", "dev", "--host", "0.0.0.0"]
