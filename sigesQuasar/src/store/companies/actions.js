import axios from 'axios';
import { CONFIG } from '../../config';
  
export function XactUserCompaniesAll (context) {
    return axios.get(CONFIG.api_url + '/user/companies')
        .then((response) => {
            console.log(response);
            context.commit('MUT_COMPANIES_LIST', response.data || []);
            context.commit('MUT_COMPANIES_TOTAL');
        })
        .catch(errors => {
            console.log('errors: ', errors.response);
        });
        
}

export function actCompanyAdd (context, customer) {
    context.commit('MUT_COMPANY_ADD', customer);
}
