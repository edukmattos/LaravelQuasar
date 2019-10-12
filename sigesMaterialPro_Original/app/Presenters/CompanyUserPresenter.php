<?php

namespace App\Presenters;

use App\Transformers\CompanyUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyUserPresenter.
 *
 * @package namespace App\Presenters;
 */
class CompanyUserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyUserTransformer();
    }
}
