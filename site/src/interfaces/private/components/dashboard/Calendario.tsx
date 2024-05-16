import { useCalendar } from "@/services/calendar/queries";

const Calendario = () => {
    const { data: getCalendar } = useCalendar();

    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Calendário</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap lg:flex-nowrap">
                <div className="bg-azul-claro rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Programas
                </div>
                <div className="bg-roxo rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Lives
                </div>
                <div className="bg-vermelho rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Youtube
                </div>
                <div className="bg-verde rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Podcasts
                </div>
                <div className="bg-azul-claro rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                </div>
                <div className="bg-azul-claro rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                </div>
                <div className="bg-azul-claro rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                </div>
            </div>
            <div className="mt-6 flex justify-center lg:justify-start gap-2 flex-wrap lg:flex-nowrap">
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Dom
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Seg
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Ter
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Qua
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Qui
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Sex
                </div>
                <div className="rounded-md text-center font-averta font-extrabold italic uppercase text-aurora text-lg w-full sm:w-1/4 lg:w-1/2">
                    Sáb
                </div>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap lg:flex-nowrap">
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* DOMINGO */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'dom') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* SEGUNDA */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'seg') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* TERÇA */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'ter') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* QUARTA */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'qua') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* QUINTA */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'qui') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* SEXTA */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'sex') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
                <div className="rounded-md text-center w-full sm:w-1/4 lg:w-1/2"> {/* SÁBADO */}
                    {getCalendar?.eventos?.sort((a: any, b: any) => a.hour.localeCompare(b.hour)).map((evento: any, index: any) => {
                        if (evento.day === 'sab') {
                            return (
                                <div key={index} className="rounded-md text-center w-full">
                                    <div className={`rounded-md w-full p-2 mb-3 ${evento.category === 'lives' ? 'bg-roxo' :
                                            evento.category === 'youtube' ? 'bg-vermelho' :
                                                evento.category === 'podcasts' ? 'bg-verde' :
                                                    'bg-azul-claro'
                                        }`}>
                                        <span className="font-averta font-regular text-aurora text-2xl">{evento.hour.replace(/:00$/, 'H')}</span>
                                        <h1 className="font-averta font-extrabold uppercase italic text-lg text-aurora pt-3 pb-3">{evento.content}</h1>
                                        <span className="block w-full text-right font-averta font-regular text-aurora text-sm">{evento?.responsible?.nickname}</span>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
            </div>
        </section>
    );
}

export default Calendario;