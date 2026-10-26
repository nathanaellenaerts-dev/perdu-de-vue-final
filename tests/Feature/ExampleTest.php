<?php

test('la page d’accueil redirige vers la liste des objets', function () {
    $response = $this->get('/');

    $response->assertRedirect('/objets');
});
