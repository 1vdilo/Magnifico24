<?

namespace utils;

class Route
{
	public static $list = [];
	public static function Get($url, $namePages)
	{
		self::$list[] = [
			'url' => $url,
			'method' => $namePages
		];
	}
	public static function Post($url, $class, $method)
	{
		self::$list[] = [
			'url' => $url,
			'class' => $class,
			'method' => $method
		];
	}

	public static function Contens()
	{
		$rout = $_GET['rout'] ?? '';
		foreach (self::$list as $item) {

			if ($item['url'] === '/' . $rout) {
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$method = $item['method'];
					$action = new $item['class'];
					$action->$method($_POST);
					die();
				} else {
					require_once __DIR__ . '/../../view/pages/' . $item['method'] . '/' . $item['method'] . '.php';
					die();
				}
			}
		}
	}
}
