import router from "@/router";

export default function auth ({ next, store }){
    console.log("the token is ", store.$state.token);
    if(!store.$state.token){
        window.location.href = router.resolve({name: 'login'}).href;
    }

    return next();
}
