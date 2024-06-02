import usePageName from '@/hooks/usePageName';
import DivisorDeTiposDeMaterias from '@/interfaces/private/components/materias/DivisorDeTiposDeMaterias';
import ImagemEmDestaqueDaMateria from '@/interfaces/private/components/materias/ImagemEmDestaqueDaMateria';
import TituloDaMateria from '@/interfaces/private/components/materias/TituloDaMateria';
import CapaDaMateria from '@/interfaces/private/components/materias/CapaDaMateria';
import EscrevaSuaMateria from '@/interfaces/private/components/materias/EscrevaSuaMateria';
import PrimeiraTagDaMateria from '@/interfaces/private/components/materias/PrimeiraTagDaMateria';
import SegundaTagDaMateria from '@/interfaces/private/components/materias/SegundaTagDaMateria';
import PrimeiraFonteDePesquisaDaMateria from '@/interfaces/private/components/materias/PrimeiraFonteDePesquisaDaMateria';
import SegundaFonteDePesquisaDaMateria from '@/interfaces/private/components/materias/SegundaFonteDePesquisaDaMateria';
import ControlesDePublicacaoDaMateria from '@/interfaces/private/components/materias/ControlesDePublicacaoDaMateria';

const Materias = () => {
    usePageName('Matérias');

    return (
        <>
            <DivisorDeTiposDeMaterias />
            <form>
                <div className="flex gap-4 mt-5 flex-wrap sm:flex-nowrap">
                    <div className='w-full sm:w-56 md:w-64 p-0 m-0 flex-shrink-0'>
                        <ImagemEmDestaqueDaMateria />
                    </div>
                    <div className='flex-grow'>
                        <TituloDaMateria />
                        <CapaDaMateria />
                        <EscrevaSuaMateria />
                    </div>
                </div>
                <div className="flex justify-end flex-wrap sm:flex-nowrap gap-5 xl:gap-14 mt-5">
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <PrimeiraTagDaMateria />
                    </div>
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <SegundaTagDaMateria />
                    </div>
                </div>
                <div className="flex justify-end flex-wrap sm:flex-nowrap gap-5 xl:gap-14 mt-5">
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <PrimeiraFonteDePesquisaDaMateria />
                    </div>
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <SegundaFonteDePesquisaDaMateria/>
                    </div>
                </div>
                <ControlesDePublicacaoDaMateria />
            </form>
        </>
    );
}

export default Materias;