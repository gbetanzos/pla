.PHONY: help build up down deploy logs clean

help:
	@echo "Available targets:"
	@echo "  build    - Build Docker images"
	@echo "  up       - Start services"
	@echo "  down     - Stop services"
	@echo "  deploy   - Deploy to Kubernetes"
	@echo "  logs     - View logs"
	@echo "  clean    - Clean up"

build:
	docker-compose build
	docker-compose build -f k8s/Dockerfile

up:
	docker-compose up -d

down:
	docker-compose down

deploy:
	kubectl apply -f k8s/

logs:
	kubectl logs -f -l app=laravel

clean:
	docker-compose down -v
	docker system prune -f