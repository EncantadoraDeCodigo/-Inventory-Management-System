const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["./Alert-1.0.31-CW3F7gbN.js","./cm-1.0.31-BzgG35ZX.js","./redux-1.0.31-CuzmJMK6.js","./vendor-1.0.31-BmpNFhoq.js","./index-1.0.31-ujFQUobk.js","./iconBase-1.0.31-C37NsRUm.js","./Typography-1.0.31-BdhCS1KD.js","./lib-1.0.31-BbX3jq4e.js","./loglevel-1.0.31-BZ7XahX3.js","./lodash-1.0.31-BtCjXqrS.js","./moment-1.0.31-C5S46NFB.js","./AlertTitle-1.0.31-Zosaacrw.js","./createSvgIcon-1.0.31-BC4iq9Gi.js","./Close-1.0.31-BTPwVQpD.js"])))=>i.map(i=>d[i]);
import{_ as l}from"./main-1.0.31.js";import{j as e}from"./cm-1.0.31-BzgG35ZX.js";import{r as o}from"./redux-1.0.31-CuzmJMK6.js";import{A as p}from"./AdminMetaData-1.0.31-Dt7brYzF.js";import{l as a,v as c}from"./lib-1.0.31-BbX3jq4e.js";/* empty css                    */import"./vendor-1.0.31-BmpNFhoq.js";import"./notistack-1.0.31-CuGQWCbt.js";import"./loglevel-1.0.31-BZ7XahX3.js";import"./lodash-1.0.31-BtCjXqrS.js";import"./moment-1.0.31-C5S46NFB.js";import"./RestApi-1.0.31-C4KxgDIV.js";import"./ActionsDml-1.0.31-DnIQKtBi.js";import"./StoreTypeEnum-1.0.31-nL46tw9S.js";import"./FallbackSpinner-1.0.31-B4qqxHwC.js";import"./Spinner-1.0.31-Be7r01J6.js";import"./Typography-1.0.31-BdhCS1KD.js";const t=o.lazy(()=>l(()=>import("./Alert-1.0.31-CW3F7gbN.js"),__vite__mapDeps([0,1,2,3,4,5,6,7,8,9,10,11,12,13]),import.meta.url));function D({dataSource:s}){a.debug(s);let i="",m="";try{let r={};try{r=JSON.parse(s.replaceAll("'",'"'))}catch(n){return console.error("JSON parse error"),a.error(n),e.jsx(o.Suspense,{children:e.jsx(t,{severity:"error",message:"Invalid arguments - check console for more information",close:!1})})}if(r.dbs&&r.tbl)i=r.dbs,m=r.tbl;else return console.error("Invalid arguments"),e.jsx(o.Suspense,{children:e.jsx(t,{severity:"error",message:"Invalid arguments - check console for more information",close:!1})})}catch(r){return console.error("Invalid arguments",r),e.jsx(o.Suspense,{children:e.jsx(t,{severity:"error",message:"Invalid arguments - check console for more information",close:!1})})}return e.jsx(p,{appId:c(),dbs:i,tbl:m})}export{D as default};
