.PHONY: up down test

up: ## Start the application
	docker-compose up -d --build
	@echo "✅ Application running at http://localhost:8000"

down: ## Stop the application
	docker-compose down

test: ## Run tests
	docker-compose -f docker-compose.yml exec -e APP_ENV=test app php bin/phpunit

