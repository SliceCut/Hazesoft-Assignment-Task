import router from "@/router";

export default function guest ({ next, store }){
    if(store.$state.token){
        window.location.href = router.resolve({name: 'company.index'}).href;
    }

    return next();
}
