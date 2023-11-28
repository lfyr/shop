build:
	@docker build -t shop .
run:build
	@docker run --name shop  -p 8082:80 -d shop

clean:
	@docker stop shop
	@docker rm shop
	@docker rmi shop
	@echo "停止成功 (^_^)v️"