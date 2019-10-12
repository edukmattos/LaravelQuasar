import axios from 'axios';
import { SessionStorage } from 'quasar';
import { CONFIG } from '../../config';
  
export function actUserCompaniesAll (context) {
    let user = SessionStorage.get.item('user');
    axios
        .get(CONFIG.api_url + '/companies/user/' + user.id)
        .then((response) => {
            context.commit('MUT_USER_COMPANIES_LIST', response.data.data || []);
            //context.commit('MUT_COMPANIES_TOTAL');
        })
        .catch(error => {
            console.log('error: ', error.response);
        });
        
}

export function actUserCompanyAdd (context, company) {
    //Add company in state
    context.commit('MUT_USER_COMPANY_ADD', company);

    //Add in dataTable company_user
    let user = SessionStorage.get.item('user');
    console.log("User: ", user);
    axios
        .post(CONFIG.api_url + '/companies/user', {company_id: company.id, user_id: user.id})
        .then((response) => {
            return response;
        })
}

export function actUserCompaniesClear (context) {
    context.commit('MUT_USER_COMPANIES_CLEAR');    
}

