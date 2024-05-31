import usePageName from '@/hooks/usePageName';
import DivisorDeTiposDeMaterias from '@/interfaces/private/components/materias/DivisorDeTiposDeMaterias';
import ImagemEmDestaqueDaMateria from '@/interfaces/private/components/materias/ImagemEmDestaqueDaMateria';
import TituloDaMateria from '@/interfaces/private/components/materias/TituloDaMateria';
import CapaDaMateria from '@/interfaces/private/components/materias/CapaDaMateria';
import EscrevaSuaMateria from '@/interfaces/private/components/materias/EscrevaSuaMateria';

const Materias = () => {
    usePageName('Matérias');

    return (
        <>
            <DivisorDeTiposDeMaterias />
            <form>
                <div className="flex gap-4 mt-5">
                    <div className='w-64 p-0 m-0 flex-shrink-0'>
                        <ImagemEmDestaqueDaMateria />
                    </div>
                    <div className='flex-grow'>
                        <TituloDaMateria />
                        <CapaDaMateria />
                        <EscrevaSuaMateria />
                    </div>
                </div>
            </form>
        </>
    );
}

export default Materias;