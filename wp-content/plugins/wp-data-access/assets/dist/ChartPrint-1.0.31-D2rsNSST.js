import{j as t}from"./cm-1.0.31-BzgG35ZX.js";import{r as p}from"./redux-1.0.31-CuzmJMK6.js";import{S as j}from"./SanitizeComponent-1.0.31-Dhv0AQbJ.js";import{F as v,M as C,J as S}from"./cjs-1.0.31-B-_HdexB.js";import{l as w}from"./lib-1.0.31-BbX3jq4e.js";import{u as T}from"./useChartType-1.0.31-DBqf3kOJ.js";import{B as l}from"./Spinner-1.0.31-Be7r01J6.js";import{I as x}from"./iconBase-1.0.31-C37NsRUm.js";import{S as q}from"./Slider-1.0.31-BDZ4XVru.js";import"./vendor-1.0.31-BmpNFhoq.js";import"./dompurify-1.0.31-CCJo14B2.js";import"./Typography-1.0.31-BdhCS1KD.js";import"./notistack-1.0.31-CuGQWCbt.js";import"./loglevel-1.0.31-BZ7XahX3.js";import"./lodash-1.0.31-BtCjXqrS.js";import"./moment-1.0.31-C5S46NFB.js";import"./RestApi-1.0.31-C4KxgDIV.js";import"./AdminTheme-1.0.31-QbwKcRV7.js";import"./useControlled-1.0.31-27-LkxG9.js";import"./visuallyHidden-1.0.31-Dan1xhjv.js";import"./Menu-1.0.31-BOTBPSPr.js";const Y=({appId:o,getChartImageURI:g,printChart:f,setPrintChart:s})=>{var m,u,d,h;const a=T(o),c=p.useRef(null),i=()=>window.document.querySelector(`#pp-chart-${o} .pp-chart-google-container svg`),[n,A]=p.useState(((m=i())==null?void 0:m.clientWidth)??0),b=()=>{var r;const e=window.open("","print");e==null||e.document.write("<html><head><title>"+document.title+"</title>"),e==null||e.document.write("</head><body >"),e==null||e.document.write("<h1>"+document.title+"</h1>"),e==null||e.document.write(((r=c.current)==null?void 0:r.innerHTML)??""),e==null||e.document.write("</body></html>"),e==null||e.document.close(),e==null||e.focus(),e==null||e.print(),e==null||e.close()},y=()=>{const e=window.document.querySelector(`#pp-chart-${o} div div`);if(e===null)return null;const r=e==null?void 0:e.cloneNode(!0);return r&&r.removeAttribute("id"),t.jsx(l,{className:"pp-chart-print-container",children:t.jsx(j,{html:r.innerHTML})})};return a==="Gauge"||a==="Table"?null:t.jsx(v,{open:f,onClose:()=>s(!1),"aria-labelledby":"modal-modal-title","aria-describedby":"modal-modal-description",children:t.jsx(l,{sx:{position:"absolute",top:"50%",left:"50%",transform:"translate(-50%, -50%)",bgcolor:"background.paper",border:"1px solid #eee",boxShadow:24,p:4,borderRadius:"4px",width:window.document.querySelectorAll(`#pp-chart-${o} svg`)!==null?(u=i())==null?void 0:u.clientWidth:"auto",height:window.document.querySelectorAll(`#pp-chart-${o} svg`)!==null?(((d=i())==null?void 0:d.clientHeight)??0)+70:"auto"},children:t.jsxs(l,{sx:{position:"relative",display:"grid",gridTemplateRows:"1fr",height:"-webkit-fill-available"},children:[t.jsx(x,{color:"primary",onClick:()=>{s(!1)},sx:{position:"absolute",right:0},children:t.jsx(C,{})}),t.jsxs(l,{sx:{display:"grid",gridTemplateRows:window.document.querySelectorAll(`#pp-chart-${o} svg`).length===1?"1fr 60px":"1fr 40px",height:"-webkit-fill-available"},children:[t.jsx(l,{ref:c,sx:{alignSelf:"center",textAlign:"center"},children:window.document.querySelectorAll(`#pp-chart-${o} svg`)!==null?t.jsx("img",{src:g(),style:{width:n}}):y()}),t.jsxs(l,{sx:{display:"grid",gridTemplateColumns:"1fr auto",justifyContent:"space-between",alignItems:"center"},children:[t.jsx(l,{children:i()!==null&&t.jsx(q,{value:n,min:1,max:(h=i())==null?void 0:h.clientWidth,step:1,valueLabelDisplay:"on",disabled:!0,onChange:(e,r)=>{w.debug(e,r)},sx:{width:"calc(100% - 40px)",margin:"20px"}})}),t.jsx(x,{color:"primary",onClick:()=>{b()},children:t.jsx(S,{})})]})]})]})})})};export{Y as default};
