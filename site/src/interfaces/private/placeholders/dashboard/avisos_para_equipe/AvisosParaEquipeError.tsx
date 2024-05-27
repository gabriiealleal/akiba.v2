import { RiArrowRightDoubleLine } from 'react-icons/ri';

interface AvisosParaEquipeErrorProps {
    nickname?: string;
}

const AvisosParaEquipeError: React.FC<AvisosParaEquipeErrorProps> = ({ nickname }) => {
    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Avisos para a equipe</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                <div className="bg-gray-700 w-full md:w-5/12 xl:w-96 h-40 p-2 rounded-sm">
                    <h1 className="text-aurora text-xl uppercase font-averta font-extrabold italic flex items-center gap-1">
                       Aki-chan <RiArrowRightDoubleLine className="mt-1" /> {nickname}
                    </h1>
                    <p className="mt-1 text-sm text-aurora line-clamp-5 font-averta">
                        Parece que você não é muito importante ou você dormiu assistindo animes e esqueceram de você!
                        Quando alguém lembrar de você serei a primeira a te avisar!
                    </p>
                </div>
            </div>
        </section>
    );
}

export default AvisosParaEquipeError;
