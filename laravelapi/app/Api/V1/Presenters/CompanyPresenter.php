<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\CompanyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class CompanyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyTransformer();
    }
}
