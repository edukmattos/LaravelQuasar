<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\BusinessTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BusinessTypePresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class BusinessTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BusinessTypeTransformer();
    }
}
