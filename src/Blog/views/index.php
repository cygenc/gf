<?= $renderer->render('header') ?>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<h1>Bienvenue sur le blog</h1>
<ul>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-1']) ?>">Article 1</a></li>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-2']) ?>">Article 2</a></li>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-3']) ?>">Article 3</a></li>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-4']) ?>">Article 4</a></li>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-5']) ?>">Article 5</a></li>
  <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'azeaze-6']) ?>">Article 6</a></li>
</ul>
<?= $renderer->render('footer') ?>
