<x-layout.main>
    <div class="navbar">
        <div class="navbar-start">
            <div class="block">
                <h1 class="title is-4">My TODOs</h1>
                <h2 class="subtitle is-6 is-italic">
                    Completing your tasks brings a sense of achievement, increases productivity,
                    reduces stress, and helps you manage your time effectively. It creates a
                    positive feedback loop, encourages you to prioritize important tasks, and
                    provides opportunities to reward yourself. So, dive in, conquer your tasks,
                    and enjoy the numerous benefits that come with it! You've got this!
                </h2>
            </div>
        </div>
        <div class="navbar-end">
            <a href="{{ route('tasks.create') }}" class="button is-primary">Create a New Task</a>
        </div>
    </div>
    <div class="block">
        @foreach($tasks as $task)
            <x-task.list-item :task="$task"></x-task.list-item>
        @endforeach
    </div>
</x-layout.main>

docker build -t my-laravel-webserver .
docker run --name mysql-container --network laravel-network -e MYSQL_ROOT_PASSWORD=laravel_password -e MYSQL_DATABASE=example_app -e MYSQL_USER=laravel_user -e MYSQL_PASSWORD=laravel_password -d mysql:8.0
docker run --name laravel-container --network laravel-network -p 8080:80 -v "$(pwd):/var/www/html" laravel-app
docker run --name laravel-container --network laravel-network -p 8080:80 -v "$(pwd):/var/www/html" my-laravel-webserver
