#!/bin/bash

# Shopping List App - Run Script
# Usage: ./run.sh

CONTAINER_NAME="shopping-app"
CONTAINER_ID=""

# Function to get container id
get_container_id() {
    docker ps -q --filter "name=${CONTAINER_NAME}";
}

# Function to check if container exists
check_container_exists() {
    if container_exists=true; then
        CONTAINER_ID=$(get_container_id);
        return 0;
    fi
    return 1;
}

# Function to start container
start_container() {
    if [ "$(get_container_id)" ]; then
        echo "Container is running";
        return 0;
    fi
    
    docker run -d \
        --name ${CONTAINER_NAME} \
        -p 8000:8000 \
        --restart unless-stopped \
        ${IMAGE}
    
    return $?;
}

# Function to stop container
stop_container() {
    docker stop ${CONTAINER_NAME};
    docker rm ${CONTAINER_NAME};
    return $?;
}

# Function to restart container
restart_container() {
    stop_container;
    start_container;
    return $?;
}

# Function to view logs
view_logs() {
    if [ -z "$1" ]; then
        docker logs -f ${CONTAINER_NAME};
    else
        tail -f $1;
    fi
}

# Command parsing
case "$1" in
    start)
        IMAGE="${IMAGE:-shopping-app}";
        start_container;
        echo "
✅ App running at: http://localhost:8000
📦 Products: http://localhost:8000/products
🛒 Shopping Lists: http://localhost:8000/shopping-list";
        ;;
    stop)
        stop_container;
        echo "⏹️  Container stopped and removed";
        ;;
    restart)
        restart_container;
        echo "🔄 Container restarted";
        ;;
    logs)
        view_logs $2;
        ;;
    status)
        if [ "$(get_container_id)" ]; then
            echo "✅ Container is running:";
            docker ps --format "table {{.ID}}\t{{.Names}}\t{{.Status}}";
        else
            echo "❌ Container is not running";
        fi
        ;;
    shell|bash)
        bash;
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|logs|status|bash}";
        echo "";
        echo "Commands:";
        echo "  start      - Start the container";
        echo "  stop       - Stop and remove the container";
        echo "  restart    - Restart the container";
        echo "  logs       - View container logs";
        echo "  status     - Check container status";
        echo "  bash       - Open interactive shell";
        exit 1;
        ;;
esac
