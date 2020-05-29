## Environment

Run the environment with `docker-compose up -d`.

If there is no container, build the docker container with `docker-compose build app`.

Run commands in the app by prepending your command with `docker-compose exec app`.

Or ssh into the docker shell: `docker exec -it app bash`.

Run NPM commands with `docker-compose run --rm npm `.

Start dev environment with `docker-compose run --rm npm run dev`.

Start asset watcher with `docker-compose run --rm npm run watch`.

View app in browser at `http://localhost:8000/`


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
