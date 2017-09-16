<?php
namespace Framework\Renderer;

/**
 * Class PHPRenderer
 */
class PHPRenderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = '__MAIN';

    /**
     * @var array
     */
    private $paths = [];

    /**
      * Variables globales accessibles pour toutes les vues
      * @var array
    */
    private $globals = [];

    /**
     * Renderer constructor.
     * @param null|string $defaultPath
     */
    public function __construct(?string $defaultPath = null)
    {
        if (null !== $defaultPath) {
            $this->addPath($defaultPath);
        }
    }

    /**
      * Permet d'ajouter un chemin pour charger des vues
      * @param string $namespace
      * @param null|string $path
    */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (null === $path) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    /**
      * Permet de rendre une vue
      * Le chemin peut être précisé avec des namespaces rajoutés via addPath()
      * $this->render('@blog/view');
      * $this->render('view');
      * @param string $view
      * @param array $params
      * @return string
    */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
      * Permet d'ajouter des variables globales à toutes les vues
      * @param string $key
      * @param mixed $value
    */
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * @param string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    /**
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    /**
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
