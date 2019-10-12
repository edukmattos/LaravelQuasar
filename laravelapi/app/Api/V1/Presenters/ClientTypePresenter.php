<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientTypePresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientTypeTransformer();
    }
}
