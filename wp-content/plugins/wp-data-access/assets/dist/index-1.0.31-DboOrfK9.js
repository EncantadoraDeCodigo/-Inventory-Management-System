import{q as h,d as p}from"./Typography-1.0.31-BdhCS1KD.js";import{r as f,b as E}from"./redux-1.0.31-CuzmJMK6.js";import{_ as v}from"./cjs-1.0.31-B-_HdexB.js";import{b as Q}from"./iconBase-1.0.31-C37NsRUm.js";function S(n,r,e,s,c){const[t,m]=f.useState(()=>c&&e?e(n).matches:s?s(n).matches:r);return Q(()=>{if(!e)return;const o=e(n),a=()=>{m(o.matches)};return a(),o.addEventListener("change",a),()=>{o.removeEventListener("change",a)}},[n,e]),t}const g={...E},l=g.useSyncExternalStore;function b(n,r,e,s,c){const t=f.useCallback(()=>r,[r]),m=f.useMemo(()=>{if(c&&e)return()=>e(n).matches;if(s!==null){const{matches:u}=s(n);return()=>u}return t},[t,n,s,c,e]),[o,a]=f.useMemo(()=>{if(e===null)return[t,()=>()=>{}];const u=e(n);return[()=>u.matches,i=>(u.addEventListener("change",i),()=>{u.removeEventListener("change",i)})]},[t,e,n]);return l(a,o,m)}function w(n={}){const{themeId:r}=n;return function(s,c={}){let t=h();t&&r&&(t=t[r]||t);const m=typeof window<"u"&&typeof window.matchMedia<"u",{defaultMatches:o=!1,matchMedia:a=m?window.matchMedia:null,ssrMatchMedia:d=null,noSsr:u=!1}=v({name:"MuiUseMediaQuery",props:c,theme:t});let i=typeof s=="function"?s(t):s;return i=i.replace(/^@media( ?)/m,""),(l!==void 0?b:S)(i,o,a,d,u)}}const T=w({themeId:p});export{T as u};
