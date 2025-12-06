COMPOSE := docker compose
COMPOSE_FILE ?= docker-compose.yaml
SERVICE := web

.PHONY: setup up bash down logs

setup:
	$(COMPOSE) -f $(COMPOSE_FILE) build
	
up:
	$(COMPOSE) -f $(COMPOSE_FILE) up -d

shell:
	@$(COMPOSE) -f $(COMPOSE_FILE) exec $(SERVICE) bash 

down:
	$(COMPOSE) -f $(COMPOSE_FILE) down

stop:
	$(COMPOSE) -f $(COMPOSE_FILE) stop

logs:
	$(COMPOSE) -f $(COMPOSE_FILE) logs -f -n 0