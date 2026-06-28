# Shopping List App - Docker Startup Instructions

## Current Error
`docker-compose` has a known bug in your system. Using `docker run` instead.

## Quick Start

```bash
cd /home/developer/pla/shopping

# Option 1: Use run.sh script (recommended)
./run.sh start

# Option 2: Direct docker command
IMAGE=shopping-app docker run -d \
    --name shopping-app \
    -p 8000:8000 \
    --restart unless-stopped \
    ${IMAGE:-shopping-app}
```

## Available Commands

```bash
./run.sh start     # Start container
./run.sh stop      # Stop and remove
./run.sh restart   # Restart
./run.sh logs      # View logs
./run.sh status    # Check status
./run.sh bash      # Open shell
```

## Access App

- 📱 **App**: http://localhost:8000
- 🧾 **Products**: http://localhost:8000/products
- 🛒 **Lists**: http://localhost:8000/shopping-list

## Verify it's running

```bash
docker ps
docker logs -f shopping-app
```
