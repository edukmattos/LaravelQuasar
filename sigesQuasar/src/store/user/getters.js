export function getUserCompaniesAll (state) {
    console.log("state companies: ", state.companies);
    return state.companies;
}

export const getUserCompanyById = (state) => (index) => {
    //console.log('index: ', index);
    let company_id = Number(index);
    //console.log('number_company_id: ', company_id);
    return state.companies.find(company => company.id === company_id);
}

export function getCompaniesTotal (state) {
    return state.total;
}
