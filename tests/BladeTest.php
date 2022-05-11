<?php

it('can render a Blade view', function () {
    expect(blade()->make('hello')->render())
        ->toContain('Hello');
});

it('can register custom directives', function () {
    blade()->directive('hello', fn () => '<?php echo "Hello"; ?>');

    expect(blade()->make('directive')->render())
        ->toContain('Hello');
});

it('can share data', function () {
    blade()->share('name', 'Ryan');

    expect(blade()->make('shared')->render())
        ->toContain('Ryan');
});
