import { Link } from "react-router-dom";
import { FaEye, FaPenNib  } from "react-icons/fa";

const UltimasMaterias = () => {
    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Últimas matérias</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                <div className="bg-azul-claro w-full sm:w-1/4 xl:w-19.45% h-40 p-2 rounded-md">
                    <h1 className="text-aurora text-sm uppercase font-averta line-clamp-5">
                        Um titulo de uma matéria muito show de bola para todo mundo comentar e encher a boca do balão e muito mais nessa caralha de web radio 
                    </h1>
                    <div className="flex justify-between mt-5">
                        <span className="text-aurora font-averta font-extrabold italic uppercase">Neko Kirame</span>
                        <div className="flex gap-2">
                            <Link to="#" className="text-aurora font-averta font-extrabold italic uppercase flex items-center gap-1">
                                <FaEye className="text-aurora text-xl"/>
                            </Link>
                            <Link to={`materias/SLUG DA MATÉRIA`} className="text-aurora font-averta font-extrabold italic uppercase flex items-center gap-1">
                                <FaPenNib className="text-aurora"/>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default UltimasMaterias;