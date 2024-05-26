import { BsSoundwave } from "react-icons/bs";
import { FaSatellite, FaHeadphones } from "react-icons/fa";
import useStreaming from "@/hooks/useStreaming";

const StatusSiteRadio = () => {
    const streamingData = useStreaming();

    return(
        <section className="mt-8">
            <div className="title-default">
                <h1>Status do site e rádio</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-5 lg:gap-2 flex-wrap xl:flex-nowrap">
                <div className="flex gap-2 items-center gap-1 text-laranja font-averta uppercase text-2xl lg:border-r lg:border-solid lg:border-slate-800 lg:pr-4">
                    <BsSoundwave className="text-azul-claro"/> {streamingData?.plano_bitrate}
                </div>
                <div className="flex gap-2 items-center gap-1 text-laranja font-averta uppercase text-2xl lg:border-r lg:border-solid lg:border-slate-800 lg:pl-2 lg:pr-3">
                    <FaSatellite className="text-azul-claro"/> {streamingData?.status === "Ligado" ? "Online" : "Offline"}
                </div>
                <div className="flex gap-2 items-center gap-1 text-laranja font-averta uppercase text-2xl lg:pl-1">
                    <FaHeadphones className="text-azul-claro"/> {Number(streamingData?.ouvintes_conectados) +  " Ouvintes"} 
                </div>
            </div>
        </section>
    );
}

export default StatusSiteRadio;