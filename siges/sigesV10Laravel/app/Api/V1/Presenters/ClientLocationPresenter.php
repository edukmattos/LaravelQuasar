<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientLocationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientLocationPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientLocationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientLocationTransformer();
    }
}
