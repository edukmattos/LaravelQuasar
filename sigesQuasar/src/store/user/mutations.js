export function MUT_USER_COMPANIES_LIST (state, companies) {
    //console.log("MUT_USER_COMPANIES_LIST: ", companies);
    state.companies = companies;
}

//export function MUT_COMPANIES_TOTAL (state) {
//    state.total = state.companies.length;;
//}

export function MUT_USER_COMPANY_ADD (state, company) {
    console.log("company: ", company);
    state.companies.push(company);
}

export function MUT_USER_COMPANIES_CLEAR (state) {
    state.companies = [];
}