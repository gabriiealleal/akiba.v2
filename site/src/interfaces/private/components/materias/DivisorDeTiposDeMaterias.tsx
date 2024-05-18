import { Link } from "react-router-dom";

const DivisorDeTiposDeMaterias = () => {
    return(
        <section>
            <div className="title-default">
                <h1>Criar matérias</h1>
            </div>
            <div className="flex gap-3 justify-center mt-3">
                <Link to="#" title="#" className="border-4 border-azul-claro pr-4 pl-4 rounded-xl font-averta font-extrabold italic text-2xl text-azul-claro uppercase">
                    Matéria
                </Link>
                <Link to="#" title="#" className="border-4 border-roxo2 pr-4 pl-4 rounded-xl font-averta font-extrabold italic text-2xl text-roxo2 uppercase">
                    Review
                </Link>   
                <Link to="#" title="#" className="border-4 border-laranja2 pr-4 pl-4 rounded-xl font-averta font-extrabold italic text-2xl text-laranja2 uppercase">
                    Evento
                </Link>           
            </div>
        </section>
    );
}

export default DivisorDeTiposDeMaterias;