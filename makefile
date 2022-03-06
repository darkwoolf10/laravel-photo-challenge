.PHONY: go-back
go-back: ## go inside backend container
		docker exec -it pc_app /bin/bash

.PHONY: go-front
go-front: ## go inside php container
		docker exec -it front /bin/bash

.PHONY: down
down: ## down all containers
		docker-compose down

.PHONY: build
build: ## build project
		docker-compose up --build -d

