<?php

namespace App\Presenters;

use App\Transformers\BusinessTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BusinessTypePresenter.
 *
 * @package namespace App\Presenters;
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
