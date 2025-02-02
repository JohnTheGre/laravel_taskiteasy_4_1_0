<x-layout.main>
    <a href="{{ route('dashboard') }}" class="button is-text is-small has-text-grey-light">Go to the Dashboard</a>
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
            @auth
                <a href="{{ route('tasks.create') }}" class="button is-primary">Create a New Task</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button is-light">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="button is-light">Login</a>
                <a href="{{ route('register') }}" class="button is-primary">Register</a>
            @endauth
        </div>
    </div>
    @auth
        <div class="block">
            @foreach($tasks as $task)
                <x-task.list-item :task="$task"></x-task.list-item>
            @endforeach
        </div>
    @else
        <p>Please <a href="{{ route('register') }}">register</a> or <a href="{{ route('login') }}">login</a> to manage your tasks.</p>
    @endauth
</x-layout.main>
