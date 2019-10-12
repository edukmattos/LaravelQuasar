export function MUT_COMPANIES_LIST (state, companies) {
    console.log("MUT_COSTUMERS: ", companies);
    state.companies = companies;
}

export function MUT_COMPANIES_TOTAL (state) {
    state.total = state.companies.length;;
}

export function MUT_COMPANY_ADD (state, company) {
    state.companies.push(company);
}