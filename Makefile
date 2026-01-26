COMPOSE := docker compose
COMPOSE_FILE ?= docker-compose.yaml
SERVICE := web

DEFAULT_GOAL := help
.PHONY: help
help:
    @awk 'BEGIN {FS = ":.*?## "}; /ake^[a-zA-Z-]+:.*?## .*$$/ {printf " [32m%-15s [0m %s\n", $$1, $$2}' Makefile | sort


setup:
	$(COMPOSE) -f $(COMPOSE_FILE) build
	
up:
	$(COMPOSE) -f $(COMPOSE_FILE) up -d

shell:
	@$(COMPOSE) -f $(COMPOSE_FILE) exec -u root $(SERVICE) bash 

down:
	$(COMPOSE) -f $(COMPOSE_FILE) down

stop:
	$(COMPOSE) -f $(COMPOSE_FILE) stop

logs:
	$(COMPOSE) -f $(COMPOSE_FILE) logs -f -n 0