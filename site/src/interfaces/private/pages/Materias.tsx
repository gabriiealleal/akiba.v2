import usePageName from '@/hooks/usePageName';
import DivisorDeTiposDeMaterias from '@/interfaces/private/components/materias/DivisorDeTiposDeMaterias';
import ImagemEmDestaqueDaMateria from '@/interfaces/private/components/materias/ImagemEmDestaqueDaMateria';
import TituloDaMateria from '@/interfaces/private/components/materias/TituloDaMateria';
import CapaDaMateria from '@/interfaces/private/components/materias/CapaDaMateria';

const Materias = () => {
    usePageName('Matérias');

    return (
        <>
            <DivisorDeTiposDeMaterias />
            <form>
                <div className="flex gap-4 mt-5">
                    <div className='w-72 p-0 m-0 flex-shrink-0'>
                        <ImagemEmDestaqueDaMateria />
                    </div>
                    <div className='flex-grow'>
                        <TituloDaMateria />
                        <CapaDaMateria />
                    </div>
                </div>
            </form>
        </>
    );
}

export default Materias;