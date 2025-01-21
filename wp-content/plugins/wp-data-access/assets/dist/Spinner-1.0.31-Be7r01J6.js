import{j as n}from"./cm-1.0.31-BzgG35ZX.js";import{i as B}from"./lib-1.0.31-BbX3jq4e.js";import{s as T,a as w,u as E,e as I,c as $,g as j,b as F,d as U,C as A,f as G,k as N,h as D,i as v,j as p,m as M,l as z,n as K,o as V,T as H}from"./Typography-1.0.31-BdhCS1KD.js";import{r as R}from"./redux-1.0.31-CuzmJMK6.js";function L(r={}){const{themeId:e,defaultTheme:s,defaultClassName:t="MuiBox-root",generateClassName:l}=r,u=T("div",{shouldForwardProp:a=>a!=="theme"&&a!=="sx"&&a!=="as"})(w);return R.forwardRef(function(f,c){const i=E(s),{className:d,component:x="div",...m}=I(f);return n.jsx(u,{as:x,ref:c,className:$(d,l?l(t):t),theme:e&&i[e]||i,...m})})}const O=j("MuiBox",["root"]),W=F(),Z=L({themeId:U,defaultTheme:W,defaultClassName:O.root,generateClassName:A.generate});function _(r){return G("MuiCircularProgress",r)}j("MuiCircularProgress",["root","determinate","indeterminate","colorPrimary","colorSecondary","svg","circle","circleDeterminate","circleIndeterminate","circleDisableShrink"]);const o=44,y=N`
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
`,C=N`
  0% {
    stroke-dasharray: 1px, 200px;
    stroke-dashoffset: 0;
  }

  50% {
    stroke-dasharray: 100px, 200px;
    stroke-dashoffset: -15px;
  }

  100% {
    stroke-dasharray: 100px, 200px;
    stroke-dashoffset: -125px;
  }
`,q=typeof y!="string"?D`
        animation: ${y} 1.4s linear infinite;
      `:null,J=typeof C!="string"?D`
        animation: ${C} 1.4s ease-in-out infinite;
      `:null,Q=r=>{const{classes:e,variant:s,color:t,disableShrink:l}=r,u={root:["root",s,`color${p(t)}`],svg:["svg"],circle:["circle",`circle${p(s)}`,l&&"circleDisableShrink"]};return V(u,_,e)},X=v("span",{name:"MuiCircularProgress",slot:"Root",overridesResolver:(r,e)=>{const{ownerState:s}=r;return[e.root,e[s.variant],e[`color${p(s.color)}`]]}})(M(({theme:r})=>({display:"inline-block",variants:[{props:{variant:"determinate"},style:{transition:r.transitions.create("transform")}},{props:{variant:"indeterminate"},style:q||{animation:`${y} 1.4s linear infinite`}},...Object.entries(r.palette).filter(z()).map(([e])=>({props:{color:e},style:{color:(r.vars||r).palette[e].main}}))]}))),Y=v("svg",{name:"MuiCircularProgress",slot:"Svg",overridesResolver:(r,e)=>e.svg})({display:"block"}),ee=v("circle",{name:"MuiCircularProgress",slot:"Circle",overridesResolver:(r,e)=>{const{ownerState:s}=r;return[e.circle,e[`circle${p(s.variant)}`],s.disableShrink&&e.circleDisableShrink]}})(M(({theme:r})=>({stroke:"currentColor",variants:[{props:{variant:"determinate"},style:{transition:r.transitions.create("stroke-dashoffset")}},{props:{variant:"indeterminate"},style:{strokeDasharray:"80px, 200px",strokeDashoffset:0}},{props:({ownerState:e})=>e.variant==="indeterminate"&&!e.disableShrink,style:J||{animation:`${C} 1.4s ease-in-out infinite`}}]}))),re=R.forwardRef(function(e,s){const t=K({props:e,name:"MuiCircularProgress"}),{className:l,color:u="primary",disableShrink:k=!1,size:a=40,style:f,thickness:c=3.6,value:i=0,variant:d="indeterminate",...x}=t,m={...t,color:u,disableShrink:k,size:a,thickness:c,value:i,variant:d},h=Q(m),g={},S={},P={};if(d==="determinate"){const b=2*Math.PI*((o-c)/2);g.strokeDasharray=b.toFixed(3),P["aria-valuenow"]=Math.round(i),g.strokeDashoffset=`${((100-i)/100*b).toFixed(3)}px`,S.transform="rotate(-90deg)"}return n.jsx(X,{className:$(h.root,l),style:{width:a,height:a,...S,...f},ownerState:m,ref:s,role:"progressbar",...P,...x,children:n.jsx(Y,{className:h.svg,ownerState:m,viewBox:`${o/2} ${o/2} ${o} ${o}`,children:n.jsx(ee,{className:h.circle,style:g,ownerState:m,cx:o,cy:o,r:(o-c)/2,fill:"none",strokeWidth:c})})})}),ie=({title:r,align:e=B.CENTER})=>{const s={display:"grid",gridTemplateColumns:"auto auto",gridGap:"5px",justifyContent:e,alignItems:"center"},t={marginLeft:"10px"};return n.jsxs(Z,{sx:s,children:[n.jsx(re,{}),r&&n.jsx(H,{sx:t,children:r})]})};export{Z as B,re as C,ie as S};
