import{r as a}from"./redux-1.0.31-CuzmJMK6.js";import{i as c,m as p,n as I,c as x,o as f}from"./Typography-1.0.31-BdhCS1KD.js";import{g as u}from"./MenuItem-1.0.31-CTowyoSp.js";import{L as g}from"./Menu-1.0.31-BOTBPSPr.js";import{j as L}from"./cm-1.0.31-BzgG35ZX.js";const d=t=>{const{alignItems:s,classes:o}=t;return f({root:["root",s==="flex-start"&&"alignItemsFlexStart"]},u,o)},v=c("div",{name:"MuiListItemIcon",slot:"Root",overridesResolver:(t,s)=>{const{ownerState:o}=t;return[s.root,o.alignItems==="flex-start"&&s.alignItemsFlexStart]}})(p(({theme:t})=>({minWidth:56,color:(t.vars||t).palette.action.active,flexShrink:0,display:"inline-flex",variants:[{props:{alignItems:"flex-start"},style:{marginTop:8}}]}))),j=a.forwardRef(function(s,o){const e=I({props:s,name:"MuiListItemIcon"}),{className:n,...i}=e,l=a.useContext(g),r={...e,alignItems:l.alignItems},m=d(r);return L.jsx(v,{className:x(m.root,n),ownerState:r,ref:o,...i})});export{j as L};
