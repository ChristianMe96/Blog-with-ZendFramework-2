<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 25.07.2018
 * Time: 12:28
 */

namespace Blog\View\Helper;


use Blog\Service\WeatherService;
use Zend\View\Helper\AbstractHelper;

class WeatherHelper extends AbstractHelper
{
    /**
     * @var WeatherService
     */
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getCurrentTemp()
    {
        return $this->weatherService->getCurrentTemp();
    }
}