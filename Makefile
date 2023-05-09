include .env

timenow := $(shell date)
new_release_dir_dev := /home/user/Program/Dev/rs-service/release/$(timenow)
app_dir_dev := /home/user/Program/Dev/rs-service/Dev/current
new_release_dir := /home/user/Program/Prod/rs-service/release/$(timenow)
app_dir := /home/user/Program/Dev/rs-service/Prod/current

build:
	@docker-compose up --build -d

migrate:
	@docker exec ${APP_NAME}_php /bin/sh -c 'php artisan migrate'

fresh:
	@docker exec ${APP_NAME}_php /bin/sh -c 'php artisan migrate:fresh'

build-develop:
	@eval `ssh-agent -s`
	@ssh-add ~/.ssh/*_rsa
	echo "Start clone"
	@git clone git@gitlab.com:rs-mitra-paramedika/rs-service.git $(new_release_dir_dev)
	@git checkout develop
	echo "Done"
	echo "Start composer install"
	@cd $(new_release_dir_dev)
	@composer install --prefer-dist --no-scripts -q -o
	echo "Done"
	echo "Start linking storage directory"
	@rm -rf $(new_release_dir_dev)/storage
	@ln -nfs $(app_dir_dev)/storage $(new_release_dir_dev)/storage
	echo "Done"
	echo "Start linking .env file"
	@ln -nfs $(app_dir_dev)/.env $(new_release_dir_dev)/.env
	echo "Done"
	echo "Start linking current release"
	@ln -nfs $(new_release_dir_dev) $(app_dir_dev)/current
	echo "Done"

build-production:
	@eval `ssh-agent -s`
	@ssh-add ~/.ssh/*_rsa
	echo "Start clone"
	@git clone git@gitlab.com:rs-mitra-paramedika/rs-service.git $(new_release_dir)
	echo "Done"
	echo "Start composer install"
	@cd $(new_release_dir)
	@composer install --prefer-dist --no-scripts -q -o
	echo "Done"
	echo "Start linking storage directory"
	@rm -rf $(new_release_dir)/storage
	@ln -nfs $(app_dir)/storage $(new_release_dir)/storage
	echo "Done"
	echo "Start linking .env file"
	@ln -nfs $(app_dir)/.env $(new_release_dir)/.env
	echo "Done"
	echo "Start linking current release"
	@ln -nfs $(new_release_dir) $(app_dir)/current
	echo "Done"